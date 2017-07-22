#!/usr/bin/env bash

./vendor/bin/phpdoc -c ./phpdoc.tpl.xml > ./logs/phpdoc.log
rm -rf ./docs/phpdoc-cache-*