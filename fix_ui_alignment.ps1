$file1 = "i:\Renew-hair-skin-care\renew_api\resources\views\customer.blade.php"
$content1 = Get-Content $file1 -Raw
$newContent1 = $content1 -replace '<div class="row">\s*<div class="col-md-3">', '<div class="row card-header">
                    <div class="col-md-3">'
Set-Content -Path $file1 -Value $newContent1

$file2 = "i:\Renew-hair-skin-care\renew_api\resources\views\lead.blade.php"
$content2 = Get-Content $file2 -Raw
$newContent2 = $content2 -replace 'href="add_lead.php"', 'href="add_lead"'
Set-Content -Path $file2 -Value $newContent2
