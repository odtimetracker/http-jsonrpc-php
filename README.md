# Simple JSON-RPC server for odTimeTracker

## Description

...

## API

URI | Method | Description
----|--------|------------
| `/info` | __GET__ | Return info about current server status.
| `/status` | __GET__ | Just alias for `/info`.
| `/start` | __POST__ | Start new activity.
| `/stop` | __GET__ | Stop currently running activity.
| `/activities/insert` | __POST__ | Insert activity(-ies).
| `/activities/select` | __GET__ | Select activity(-ies).
| `/activities/remove` | __POST__ | Remove activity(-ies).
| `/activities/update` | __POST__ | Update activity(-ies).
| `/projects/insert` | __POST__ | Insert project(s).
| `/projects/select` | __GET__ | Select project(s).
| `/projects/remove` | __POST__ | Remove project(s).
| `/projects/update` | __POST__ | Update project(s).


