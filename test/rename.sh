#!/bin/bash
cd wordpress/
wp search-replace "http://www.app.local" "https://www.app.local"  --skip-columns=guid 
