#!/bin/sh
exec /usr/bin/chromium-browser --no-sandbox --disable-gpu --privileged --no-first-run --no-default-browser-check --disable-features=WelcomePage,SignInProfileCreation,ExtensionsToolbarMenu --enable-force-dark --force-dark-mode --enable-features=WebUIDarkMode --enable-bookmark-reordering  "https://www.app.local"

#about:blank

