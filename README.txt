Mihir Chakravarthi and Kyle Wu
machakra9 and kwu45

No changes were made based on previous comments from Phase C and Phase D.

However, we did change out large dataset so that the database can be populated and queried.
Before this phase, our dataset was too large and we never saw the setup run to completion.
After reducing the data, it now runs in about 2-5 minutes. We chose the data by randomly selecting
100,000 stops from the original 10 states that we narrowed it down to.

We have also moved the cleanup script into the beginnings of the setup scripts and all required procedures
are setup in the setup script as well so there is no need to run any other sql files.
