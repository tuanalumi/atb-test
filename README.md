This is a test.

# Setup

1. Import database from `atb-test-23-03-18.sql.gz`
2. `composer install` - just for the autoload to work

# Usage

## Get your token

Endpoint: `GET /api.php?action=get_token&email=hayes.gage@gmail.com&password=123456`

Params: (all required)
- `action`: in this case, equal to `get_token`
- `email`: email
- `password: password. In test database, all password is `123456`

## Get user info

Endpoint: `GET /api.php?action=info&token=<YOUR TOKEN>`

Params: (all required)
- `action`: in this case, equal to `info`
- `token`: your token

## Update user info

Endpoint: `POST /api.php?action=update&token=<YOUR TOKEN>`

GET params: (all required)
- `action`: in this case, equal to `update`
- `token`: your token

### POST body

Post body are in `application/x-www-form-urlencoded` format. All field which needs to be updated can be specified using its name. 

For example:

`name=Tuan+Tran&age=51` will update `name` and `age` of the authenticated user.
