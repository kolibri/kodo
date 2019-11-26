# SFPROJECT

Workflow driven task management.

*ATTENTION*: This is currently just a playground to tests concepts, bring some "but it is possible" in the game and so son.
So, don't expect running software or even a full concept. This is just a draft of some ideas with some approaches to check, if it is possible.



## Problem to solve:

Information about a project is usually spread out through different portals.
Code lives inside the repository, documentation inside an external wiki, task management is done by another tool, etc.
The Idea ist, to bring them all into one place: The code repository.

## First concepts

1. Define a directory (default is `project`) and place markdown files for the tasks you have.
2. Create a branch names after the tasks filename. This will mark the task as "in progress"
3. Merging the branch into the `master` branch will mark the task as "done"

All the information about a tasks state is fetched from the repository itself, so no need for any external database.

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

And yes, the idea is, to possibly include the whole project into the "creating tasks" Task.

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
    Will use the actual repository on the devs machine

## Problems without solution

Pull requests are outside of the system
    APIs to github/gitlab/etc
    
Local command
