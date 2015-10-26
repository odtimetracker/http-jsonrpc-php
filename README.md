# Simple JSON-RPC server for odTimeTracker

## Description

Simple JSON-RPC server for [odTimeTracker](https://github.com/odtimetracker/) implemented in [PHP](http://php.net/).

## API

Here is table of available methods:

Method | Params | Description
----|--------|------------
`Info` | _none_ | Return info about current server status.
`Status` | _none_ | Just alias for method `Info`.
`Start` | _Activity_ | Start new activity.
`Stop` | _none_ | Stop currently running activity.
`ActivityInsert` | _Activity_ | Insert activity(-ies).
`ActivitySelect` | _Filter_ | Select activity(-ies).
`ActivityRemove` | _Filter_ | Remove activity(-ies).
`ActivityUpdate` | _Activity_ | Update activity(-ies).
`ProjectInsert` | _Project_ | Insert project(s).
`ProjectSelect` | _Filter_ | Select project(s).
`ProjectRemove` | _Filter_ | Remove project(s).
`ProjectUpdate` | _Project_ | Update project(s).

__Note__: Below are details about some parameters.

### _Activity_

#### Method `Start`

```json
{
	"ProjectId": 5,
	"Name": "Some activity",
	"Description": "Activity description",
	"Tags": "tag1,tag2"
}
```

Or:

```json
{
	"Project": "Test project",
	"Name": "Some activity",
	"Description": "Activity description",
	"Tags": "tag1,tag2"
}
```

Where `Name` and either `Project` or `ProjectId` are required and `Description` and `Tags` are optional.

#### Methods `ActivityInsert` and `ActivityUpdate`

For inserting an activity use:

```json
{
	"ProjectId": 5,
	"Name": "Some activity",
	"Description": "Updated activity description",
	"Tags": "tag1,tag2",
	"Started": "2015-06-22T15:00:00+02:00",
	"Stopped": "2015-06-22T16:00:00+02:00"
}
```

For updating activity must be also `ActivityId` included:

```json
{
	"ActivityId": 41,
	"ProjectId": 5,
	"Name": "Some activity",
	"Description": "Updated activity description",
	"Tags": "tag1,tag2,tag3",
	"Started": "2015-06-22T15:00:00+02:00",
	"Stopped": "2015-06-22T16:00:00+02:00"
}
```

### _Project_

For inserting a project use:

```json
{
	"Name": "Test project",
	"Description": "Test project description"
}
```

For updating project must be also `ProjectId` included:

```json
{
	"ProjectId": 5,
	"Name": "Test project",
	"Description": "Test project description"
}
```

### _Filter_

...

