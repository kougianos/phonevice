#!/bin/sh

php -f ./tsmarty2c.php ../templates/*.html > ./smarty.c


# el_GR
xgettext --no-location --no-wrap --join-existing -L C --force-po --foreign-user --default-domain=PhoneVice --copyright-holder="PhoneVice" --package-name="PhoneVice" --from-code=UTF-8 --directory=. --output-dir=../locale/el_GR/LC_MESSAGES/ ./smarty.c
msgfmt --output-file=../locale/el_GR/LC_MESSAGES/phonevice.mo ../locale/el_GR/LC_MESSAGES/phonevice.po
