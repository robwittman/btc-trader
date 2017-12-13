FROM php:7.2-cli

RUN mkdir /util

CMD ["php", "/util/console.php", "product:ticker"]
