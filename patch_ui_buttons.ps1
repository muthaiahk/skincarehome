$viewsDir = "i:\Renew-hair-skin-care\renew_api\resources\views\api"

$apiFiles = Get-ChildItem -Path $viewsDir -Filter *.php

foreach ($apiFile in $apiFiles) {
    if ($apiFile.Length -gt 0) {
        $content = Get-Content $apiFile.FullName -Raw
        
        # We look for things like $("#add_lead").hide(); and comment them out.
        $newContent = [regex]::Replace($content, '(\$\(["''][#\.]add_[a-zA-Z0-9_-]+["'']\)\.hide\(\);)', '// UI BYPASS: $1')
        
        if ($content -ne $newContent) {
            Set-Content -Path $apiFile.FullName -Value $newContent
            Write-Host "Patched hidden buttons in $($apiFile.Name)"
        }
    }
}
