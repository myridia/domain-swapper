#!/bin/sh
exec /usr/bin/chromium-browser --no-sandbox --disable-gpu --privileged --no-first-run --no-default-browser-check --disable-features=WelcomePage,SignInProfileCreation,ExtensionsToolbarMenu  about:blank

