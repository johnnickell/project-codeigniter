<?php

declare(strict_types=1);

$projectRoot = dirname(__DIR__);
$authorityFile = $projectRoot . '/vendor/johnnickell/fight-common/release/src/Application/StarterSupportReceiptAuthority.php';
if (! is_file($authorityFile)) {
    fwrite(STDERR, "Fight Common receipt authority is missing from the installed exact candidate.\n");
    exit(1);
}

require $projectRoot . '/scripts/framework-support-receipt.php';
require $authorityFile;

$receiptPath = $projectRoot . '/evidence/framework-support/receipt-v1.json';
if (! is_file($receiptPath)) {
    fwrite(STDERR, "Committed framework-support receipt is missing.\n");
    exit(1);
}

$receipt = json_decode((string) file_get_contents($receiptPath), true, flags: JSON_THROW_ON_ERROR);
if (! receiptHashChecksPass($receipt)) {
    fwrite(STDERR, "The committed receipt content and receipt SHA-256 values are invalid.\n");
    exit(1);
}
if (! frameworkSupportIsCurrent($projectRoot, $receipt)) {
    fwrite(STDERR, "The committed receipt does not match canonical lock, digest, evidence, or outcome requirements.\n");
    exit(1);
}

$authority = new Fight\Release\Application\StarterSupportReceiptAuthority();
if (! $authority->isValid($receipt)) {
    fwrite(STDERR, "Fight Common StarterSupportReceiptAuthority rejected the committed receipt.\n");
    exit(1);
}

fwrite(STDOUT, "Framework-support receipt passed.\n");

/** @param array<string, mixed> $receipt */
function receiptHashChecksPass(array $receipt): bool
{
    $content = $receipt;
    unset($content['content_id'], $content['evidence']['receipt_sha256']);
    $contentId = hash('sha256', json_encode($content, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));

    $digest = $receipt;
    unset($digest['evidence']['receipt_sha256']);
    $receiptDigest = hash('sha256', json_encode($digest, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR));

    return hash_equals($contentId, $receipt['content_id'] ?? '')
        && hash_equals($receiptDigest, $receipt['evidence']['receipt_sha256'] ?? '');
}
