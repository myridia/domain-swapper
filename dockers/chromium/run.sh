echo "http://127.0.0.1:5800"
docker run --rm --add-host=www.app.local:10.5.0.2  -e USER_ID=0 -e GROUP_ID=0  -p 5800:5800 -p 5900:5900 --name chromium docker-chromium


