#Log

## Setup
  - composer create-project symfony/website-skeleton:"^5.2"
  - removed mailer
  - add easyadmin

## Data
  - Tests for Entities
  - Entities
  - Migrations
  - Fixtures

## API
- Tests for Endpoint
    - /api/user
    - /api/user/:id/quotation
- Created Endpoint
- Workaround for circular exception

## CRUD
  - create in memory user: burns pw: smithers
  - Controller, Views
    (Within the 80min Timespan did not finished tests.)
  - Tests for List, Single View, Add, Edit, Delete

## How to run
  - bin/console doctrine:migrations:migrate
  - bin/console doctrine:fixtures:load
  - symfony server:start

## How to test
  -  before run: bin/console doctrine:migrations:migrate --env=test -q
  -  composer test



