#!/bin/bash

echo "[GEN: Start]"

SPWD=`pwd`
cd ../scripts

# jQuery
echo "[GEN: jQuery]"
cp $SPWD/scripts/jquery-3.3.1.min.js jquery.min.js
cp $SPWD/scripts/jquery-3.3.1.min.js custom.min.js


# custom
echo "[GEN: custom]"
java -jar ../data/yuicompressor/yuicompressor-2.4.8.jar --type js -o $SPWD/scripts/custom.min.tmp $SPWD/scripts/custom.js
cat $SPWD/scripts/custom.min.tmp >> custom.min.js
rm -rf $SPWD/scripts/custom.min.tmp
cat $SPWD/scripts/custom.js > custom.js


# Clean comments
echo "[GEN: Clean comments]"
perl -i -pe 'BEGIN{undef $/;} s/\/\*[ \!\n](.*?)\*\// /smgi' custom.min.js


# GZIP pre-compress files
gzip -f -k -9 custom.min.js


# CSS
echo "[GEN: CSS]"
cd ../css/


# figamecars
echo "[GEN: figamecars]"

cp $SPWD/css/style.css tmp.css
if [ -f "$SPWD/css/style-theme.css" ]; then
	cat $SPWD/css/style-theme.css >> tmp.css
fi
if [ -f "$SPWD/css/style-color.css" ]; then
	cat $SPWD/css/style-color.css >> tmp.css
fi
perl -i -pe 'BEGIN{undef $/;} s/\/\*[ \!\n](.*?)\*\// /smgi' tmp.css
java -jar ../data/yuicompressor/yuicompressor-2.4.8.jar --type css -o tmp2.css tmp.css
cat tmp2.css > style.min.css
gzip -f -k -9 style.min.css
mv tmp.css style.css
rm -rf tmp2.css

