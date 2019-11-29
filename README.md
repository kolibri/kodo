# KoDo

Workflow driven task management.

*ATTENTION*: This is currently just a playground/prototype to tests concepts, bring some "but it is possible" in the game and so on.
So, don't expect running software or even a full concept. This is just a draft of some ideas with some approaches to check, if it is possible.

## Setup & running tests

```bash
composer install
make create-fixtures
make
```

## Use-Case, or the problem to solve:

Information about a project is usually spread out through different portals.
Code lives inside the repository, documentation inside an external wiki, task management is done by another tool, etc.
The Idea ist, to bring them all into one place: The code repository.

Main issue here are the tasks, as non devs, aka project managers also need access (with read/write/create possibilities).
Also, state detection ("in progress", "is done", "in review") seems kinda hard or introduce a lot of overhead.

## Concept, or the idea

Main data source should be the repository itself. Starting with a directory structure like this

```
.
├── README.md
├── tasks
│   ├── sprint
│   │   └── 002-add-feature.md
│   ├── deployed
│   │   └── 000-tests-green.md
│   └── backlog
│       └── 004-we-will-do-it.md
└── src

```
You should already have all you need: Different lanes are just directories, where some tasks files live.
You might notice, that there is no "in progress" or "in review" lane, and this is ok, as the idea is, to get these states based on the repository informations:

E.g you create a branch `sprint/002-add-feature`, this task will be recognized as "in progress".
Merge this branch, and this tasks is "done" and can move to the next lane. No manual moving of tasks in an external system required.

There might be more "states", that can be applied to a task (like the mentioned "in review"). It is part of this prototype, how to define and detect these states.


## Next steps

### detect "In review" state

A tasks is "in review" if a pull request to the branch exists.
 But, pull requests are external


### Lanes

As you know them from any other "agile board", we need "lanes".
But, the idea is to only have lanes dedicated to the project task organisation workflow.
As we already have "open/in progress/done" defined by the branch/merge workflow, for a usual scrum project, we need the 
following lanes:
    
    Backlog
    Current Sprint
    (Next Sprint)
    (Finished)

Inside the repo, lanes are represented by directories.
So, in `project/backlog/` are the backlog items, in `project/current_sprint` the tasks for the current sprint, etc.
You can move tasks by moving the files into the target directory.

Another setup of lanes could be:

    Ideas (for not yet finished tasks) 
    Planned (for tasks, that are reay to take)
    Upcomming (for ready tasks, that should be done in the next sprint) 
    Current (tasks, that should be done next)
    Releases (for the finished tasks, that are deployed)

And yes, the idea is, to possibly include the whole team into the "creating tasks" Task. The result will be better task descriptions


### Definition of Done as a Script

Would be nice, if we can place some checks inside a task, to tell, if the task is finished or not 
(like little extra checks additional to all the tests, qa tools, etc. from the default build pipeline)

```bash|dod
make unit-test
curl -i http://my_site.foo/the/new/feature/url 
```


## Just why

At first, to have all infos (or at least more infos than all the jira users) inside the repository. No more knowledge islands!

Also, by enforcing pull requests even for task changes, this will increase the quality of the tasks by using the four eyes principle.

A nice side effect could/should be, that with the detection of the current state no tasks will have any invalid state 
without bothering the developer about moving tasks in an external system. Just stay with your usual dev workflow
(ok, with some exceptions/additions/conventions), and everything is fine.


## How will this be used

I'll guess, we will have two parts: 

1. A online platform, to show all the informations in a nice and clean way, useable by non devs.
    Will use a copy of the repository
2. A CLI Tool, that runs on the devs machine.
    Will use the actual repository on the devs machine (by default, with option to define the path to the target repo)

## Problems without solution

- Pull requests are outside of the system
    - APIs to github/gitlab/etc
    
- Local command
    - PHP might not be the right tool for this ;)

- Task - User association
    - Take users from commits
    - Still a problem with `git checkout -b feature && Git push -u origin feature`, because then not new commit exists in the branch to fetch user from

- Extra infos for tasks in branches other than master needs to be visible(??)

- How to integrate some state like "deployed to test system, but not stage and prod"?

