# Keep track of tasks during lanes

We should be able to track a task even when it switches lanes.
First thought/MVP:  look for move/rename in commits
Second thought: Clever code, that looks for task filename (without lane) in other commits. (For the case, that git cannot detect moving/renaming of a file)
