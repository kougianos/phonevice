#!/bin/sh

php -f ./tsmarty2c.php ../templates/*.html > ./smarty.c


# en_GB
xgettext --no-location --no-wrap --join-existing -L C --force-po --foreign-user --default-domain=PhoneVice --copyright-holder="PhoneVice" --package-name="PhoneVice" --from-code=UTF-8 --directory=. --output-dir=../locale/en_GB/LC_MESSAGES/ ./smarty.c
msgfmt --output-file=../locale/en_GB/LC_MESSAGES/phonevice.mo ../locale/en_GB/LC_MESSAGES/phonevice.po
