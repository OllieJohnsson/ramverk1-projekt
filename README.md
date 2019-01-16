# ramverk1-projekt

[![Build Status](https://travis-ci.org/OllieJohnsson/ramverk1-projekt.svg?branch=master)](https://travis-ci.org/OllieJohnsson/ramverk1-projekt)

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/OllieJohnsson/ramverk1-projekt/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/OllieJohnsson/ramverk1-projekt/?branch=master)

[![Code Coverage](https://scrutinizer-ci.com/g/OllieJohnsson/ramverk1-projekt/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/OllieJohnsson/ramverk1-projekt/?branch=master)

[![Build Status](https://scrutinizer-ci.com/g/OllieJohnsson/ramverk1-projekt/badges/build.png?b=master)](https://scrutinizer-ci.com/g/OllieJohnsson/ramverk1-projekt/build-status/master)


# Installation

#### Hämta ner en lokal version
```
git clone https://github.com/OllieJohnsson/ramverk1-projekt
```

#### Ställ dig i katalogen ramverk1-projekt
```
cd ramverk1-projekt
```

#### Installera dependencies
```
composer install
```

#### Skapa databasen
```
mysql -uroot -p*ditt root-lösenord* < sql/setup.sql
mysql -uuser -ppass rv1proj < sql/ddl.sql
mysql -uuser -ppass rv1proj < sql/insert.sql
```

#### Skapa config/database.php med standard-värden
```
rsync -av config/database_sample.php config/database.php
```

#### Fixa vendor/anax/database-active-record/src/DatabaseActiveRecord/ActiveRecordModel.php
Rad 137 returnerar inget.
Ändra från `$this->db->connect()` till `return $this->db->connect()`
