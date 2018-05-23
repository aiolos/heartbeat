# Heartbeat
An application to just get heartbeat of various devices. A device must first be created before 
it can send heartbeats.
The resulting API shows per device which are overdue. And from which IP the request came 
(handy for changing IPs)

## Installation:
- Make a checkout of this repo
- Install [composer](https://getcomposer.org)
- Set the right credentials in you `.env` file
- Run `php composer.phar install`
- Run the database migrations: `./bin/console doctrine:migrations:migrate`

## Usage
- Add host via `http://yourdomain/admin/[admin_uuid]/host/add/[name]/[TTL]`
- Get a JSON list of hosts with `http://yourdomain/admin/[admin_uuid]/host/list`
- Add a new heartbeat via `http://yourdomain/ping/[host_uuid]`
- View the list of hosts with `http://yourdomain/[admin_uuid]`

## Models:
- Heartbeat
  - ID
  - Device
  - Timestamp
  - IP
- Devices
  - Id
  - Name
  - Host(name)
  - TTL (Time to live, expected maximum time between 2 pings)
  - Hash
  
## API
- GET: `/ping/[uuid]`
  - Add a new Heartbeat record 
- GET: `/admin/[admin_uuid]/host/details/[uuid]`
  - Last update
  - Overdue
  - IP
- GET: `/admin/[admin_uuid]/host/add/[name]/[ttl]`
  - Add a new host with the given name and TTL (TTL format is the [DateInterval Duration format](https://en.wikipedia.org/wiki/ISO_8601#Durations))
- GET: `/admin/[admin_uuid]/host/list`
  - Show list of all devices with details
- Nice to have:
  - Domoticz compatible response
  - Domoticz compatible request
  - 'Uptime' percentage
  - Some kind of payload the client can send
