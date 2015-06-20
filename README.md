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
`InsertActivity` | _Activity_ | Insert activity(-ies).
`SelectActivity` | _Filter_ | Select activity(-ies).
`RemoveActivity` | _Filter_ | Remove activity(-ies).
`UpdateActivity` | _Activity_ | Update activity(-ies).
`InsertProject` | _Project_ | Insert project(s).
`SelectProject` | _Filter_ | Select project(s).
`RemoveProject` | _Filter_ | Remove project(s).
`UpdateProject` | _Project_ | Update project(s).

__Note__: Below are details about some parameters.

### _Activity_

#### Method `Start`

```
{
	"ProjectId": 5,
	"Name": "Some activity",
	"Description": "Activity description",
	"Tags": "tag1,tag2"
}
```

Or:

```
{
	"Project": "Test project",
	"Name": "Some activity",
	"Description": "Activity description",
	"Tags": "tag1,tag2"
}
```

Where `Name` and either `Project` or `ProjectId` are required and `Description` and `Tags` are optional.

#### Methods `InsertActivity` and `UpdateActivity`

For inserting an activity use:

```
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

```
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

```
{
	"Name": "Test project",
	"Description": "Test project description"
}
```

For updating project must be also `ProjectId` included:

```
{
	"ProjectId": 5,
	"Name": "Test project",
	"Description": "Test project description"
}
```

### _Filter_

...

## Usage

If you are interested in creating clients for this server:

- __PHP__: see included [PHPUnit](https://phpunit.de/) tests.
- __JavaScript__: ...
