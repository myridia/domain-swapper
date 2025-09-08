#!/bin/bash
domain='_.app.local'
rm $domain  -Rf
./minica --domains '*.app.local'


cp ./$domain/cert.pem ./$domain/www.app.local.crt
cp ./$domain/cert.pem ./$domain/ww1.app.local.crt
cp ./$domain/cert.pem ./$domain/ww2.app.local.crt
cp ./$domain/cert.pem ./$domain/ww3.app.local.crt
cp ./$domain/cert.pem ./$domain/foo.app.local.crt
cp ./$domain/cert.pem ../etc/nginx/conf.d/certs/
cp ./$domain/key.pem ./$domain/www.app.local.key
cp ./$domain/key.pem ./$domain/ww1.app.local.key
cp ./$domain/key.pem ./$domain/ww2.app.local.key
cp ./$domain/key.pem ./$domain/ww3.app.local.key
cp ./$domain/key.pem ./$domain/foo.app.local.key
cp ./$domain/key.pem ../etc/nginx/conf.d/certs/
chmod 755 ./$domain





