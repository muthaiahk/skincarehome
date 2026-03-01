$viewsDir = "i:\Renew-hair-skin-care\renew_api\resources\views"

# 1. Replace <?php include("api/...") ?> with @include('api...')
$files = Get-ChildItem -Path $viewsDir -Filter *.blade.php

foreach ($file in $files) {
    if ($file.Length -gt 0) {
        $content = Get-Content $file.FullName -Raw
        $newContent = [regex]::Replace($content, "<\?php\s+include\(`"api/(.*?)\.php`"\)\s*\?>", "@include('api.`$1')")
        $newContent = [regex]::Replace($newContent, "<\?php\s+include\('api/(.*?)\.php'\)\s*\?>", "@include('api.`$1')")

        if ($content -ne $newContent) {
            Set-Content -Path $file.FullName -Value $newContent
            Write-Host "Updated includes in $($file.Name)"
        }
    }
}

# 2. Fix base_url in api folder
$apiFiles = Get-ChildItem -Path "$viewsDir\api" -Filter *.php

foreach ($apiFile in $apiFiles) {
    if ($apiFile.Length -gt 0) {
        $apiContent = Get-Content $apiFile.FullName -Raw
        $newApiContent = $apiContent -replace "/renew_api/api/", "/api/"
        if ($apiContent -ne $newApiContent) {
            Set-Content -Path $apiFile.FullName -Value $newApiContent
            Write-Host "Updated base_url in $($apiFile.Name)"
        }
    }
}
