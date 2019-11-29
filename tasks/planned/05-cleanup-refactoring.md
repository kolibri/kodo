# Cleanup refactoring

## Problems:

`StateResolver` should not depend on Git Repo in constructor.
`Project` currently is a mix of logic and value object.
Namespace refactoring (i.e. to split value/logic objects)
Keep Caching in mind

