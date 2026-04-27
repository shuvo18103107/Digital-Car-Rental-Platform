#!/bin/bash

DATE=$(date +\%Y-\%m-\%d-\%H-\%M)
FILE="backup-$DATE.sql"
TMP_PATH="/tmp/$FILE"

# DB dump
mysqldump -u laravel -p'A.ad2&4NiC[h7' --no-tablespaces car_rental > $TMP_PATH

# Upload to S3 (Laravel disk via artisan)
php /var/www/html/digital-car-rental/artisan tinker --execute="
Storage::disk('s3')->put('backups/$FILE', file_get_contents('$TMP_PATH'));
"

# Delete temp file
rm -f $TMP_PATH

# Cleanup old backups (keep last 10)
php /var/www/html/digital-car-rental/artisan tinker --execute="
\$files = collect(Storage::disk('s3')->files('backups'))
    ->sortDesc()
    ->values();

\$files->slice(10)->each(function (\$file) {
    Storage::disk('s3')->delete(\$file);
});
"