# Heartbeat
An application to just get heartbeat of various devices. A device must first be created before 
it can send heartbeats.
The resulting API shows per device which are overdue. And from which IP the request came 
(handy for changing IPs)

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
  - Heartbeat period
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
