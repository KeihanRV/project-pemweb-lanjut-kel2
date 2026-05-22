#!/usr/bin/env bash

if [ "$1" = "add" ]; then
    if [ -z "$2" ] || [ -z "$3" ]; then
        echo "Usage: ./list-sppg.sh add <nama> <lokasi>"
        exit 1
    fi
    docker compose exec app php artisan tinker --execute="
        \$k = App\Models\Kitchen::create(['nama' => '$2', 'lokasi' => '$3', 'daftar_bahan' => '']);
        echo 'Created: ' . \$k->nama . ' | Code: ' . \$k->code . PHP_EOL;
    "
else
    docker compose exec db mysql -u root sipeka -e "SELECT nama, lokasi, code FROM kitchens ORDER BY nama;"
fi
