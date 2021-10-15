# Secret Source Bikes Anonymous PHP Sample Project

Welcome to this phase of our hiring process.

The next stage is to work on a sample project (this one) followed by a pair programming session with one or more of our developers. We will use this opportunity to see how you work. Please do something you are proud of and can explain in detail.

Attached is a short system description of a project you’ll be working on. Although the whole system could require a lot of your time, we aren’t asking you to create the whole system, just some small parts of the back end. Do just enough to fulfil the user stories, nothing more. In fact, it is even ok if you don’t finish the tasks. Our aim is to get an idea of how you work and how you write code. We will not be judging you on whether or not you finish the project.

Please approach the project in the following order:

1. Estimate the time required to complete it and inform us by replying to this email
2. Accept our invitation to the starter repository. Please do not just upload the finished code. We are very interested in seeing its progression via the commits.
3. Work on the project. You can take as long as you feel you need however we urge you not to spend more than a few hours - you do not need to finish the task but you do need to do enough for us to be able to see how you work. Remember: we are evaluating how well you would fit on a team of developers, not working in isolation. 
4. Once you have finished your work please tag your development branch as 1.0 and send us an email to info@secret-source.eu to let us know it is complete.

We will review the solution and assess the code quality, structure and use of best practices. Please do not copy code from the internet as we need to be able to evaluate your own code.

Please use this as an opportunity to show us how good you are at coding and not how quick, we are interested in quality, not quantity, in the context of a team of developers. 

Once you've finished we will organise a pair programming session where you can explain your code and add some features.

If you have any questions during the project please ask via Slack. We will add you to our Slack channel shortly and you will receive an invitation. Please use it to to ask any questions and to communicate your progress during the project.

We look forward to hearing from you.

---- 

# Backend / API Laravel

*System Description*

Bikes Anonymous is a small organization that certifies cyclists for riding on the road. They are internationally recognized with clients throughout the world who speak multiple languages. They have certified millions of riders. They run their infrastructure on Azure but use Linux on the back end. The back end consists of an API and an integrated Admin panel. The front end is web-based and interacts with the API.

BA has a nightly certification workflow that consists of

1. Receiving a CSV from a partner certification center 
2. Converting each row of the CSV into a rider’s licenses in PDF format
3. Emailing the PDF to the license holder using the email field in the CSV
4. Finally, when the whole file has been processed, the system notifies by email both the partner certification center and BA that all certifications in the CSV have been processed.

Given the amount of data processed on a daily basis, it is imperative that processing the CSV be done via a scheduled task and not as part of the upload process.

Given the relative sensitivity of the data, only authenticated users can upload a file for processing (for this sample project, please only add authentication if you have time, this is low priority for this sample project).

Using Laravel, create an API and necessary code that fulfils the following user stories.

## User Stories

- I, as an authenticated user, can upload a CSV so that BA can process the data and mail the cyclist licenses. (Note: for this story, it is not necessary to create a front end, only an endpoint and associated backend code)
- I, as a certified cyclist, can print a PDF of my license so that I can start riding immediately.
- I, as the owner of BA, can read an email containing a summary of the nightly activity so that I can gauge how well my business is doing.

## Acceptance Criteria

For this exercise, we ask that the developer elaborate the acceptance criteria they deem necessary to verify that the user stories above have been fulfilled.

----

# About this repo

This is a Laravel Sail application (Docker). We have found that for testing purposes, this is about the best approach there is. To bring the application up locally, simply cd to the project and run:

```
cp .env.example .env
php artisan key:generate
composer install
./vendor/bin/sail up
```
