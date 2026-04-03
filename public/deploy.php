<?php

// ── Config ────────────────────────────────────────────────────────────────────
define('REPO_DIR',   '/home/thenort2/repositories/pict-digital-staging');
define('WEB_ROOT',   '/home/thenort2/public_html');
define('NODE_ENV',   '/home/thenort2/nodevenv/repositories/pict-digital-staging/22/bin/activate');
define('LOG_FILE',   REPO_DIR . '/deploy.log');
define('SECRET_ENV', 'GH_DEPLOY_SECRET');

// ── Helpers ───────────────────────────────────────────────────────────────────
function logMsg(string $msg): void {
    $line = '[' . date('Y-m-d H:i:s') . '] ' . $msg . PHP_EOL;
    file_put_contents(LOG_FILE, $line, FILE_APPEND | LOCK_EX);
}

function abort(int $code, string $msg): never {
    logMsg("ABORT $code: $msg");
    http_response_code($code);
    exit($msg);
}

function run(string $cmd): array {
    exec('/bin/bash -c ' . escapeshellarg($cmd) . ' 2>&1', $output, $exitCode);
    return ['output' => implode("\n", $output), 'code' => $exitCode];
}

// ── Verify request method ─────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    abort(405, 'Method Not Allowed');
}

// ── Verify GitHub signature ───────────────────────────────────────────────────
$secret = getenv(SECRET_ENV);
logMsg("Secret check: " . ($secret ? 'found' : 'NOT FOUND'));
if (!$secret) {
    abort(500, 'Webhook secret not configured');
}

$payload   = file_get_contents('php://input');
$sigHeader = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

if (!$sigHeader) {
    abort(400, 'Missing signature');
}

$expected = 'sha256=' . hash_hmac('sha256', $payload, $secret);

if (!hash_equals($expected, $sigHeader)) {
    abort(403, 'Invalid signature');
}

// ── Only act on push events ───────────────────────────────────────────────────
$event = $_SERVER['HTTP_X_GITHUB_EVENT'] ?? '';
if ($event !== 'push') {
    http_response_code(200);
    exit("Ignored event: $event");
}

// ── Only deploy from main branch ──────────────────────────────────────────────
$data = json_decode($payload, true);
$ref  = $data['ref'] ?? '';
if ($ref !== 'refs/heads/main') {
    http_response_code(200);
    exit("Ignored ref: $ref");
}

// ── Deploy ────────────────────────────────────────────────────────────────────
logMsg("Deploy started — ref: $ref, commit: " . ($data['after'] ?? 'unknown'));

$testCmd = '/bin/bash -c ' . escapeshellarg('cd ' . REPO_DIR . ' && /usr/local/cpanel/3rdparty/lib/path-bin/git status 2>&1');
$result = run($testCmd);
logMsg("Git status test — exit={$result['code']} output={$result['output']}");
http_response_code(200);
echo 'Debug complete';
exit;
