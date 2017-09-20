# files_duplicate (ownCloud app)

Duplicate files/directories with a single click.

## Install

1. Copy [files_duplicate](files_duplicate) to your **ownCloud apps directory** (usually **/var/www/html/owncloud/apps**).
2. Enable the app via web interface or command line

## Development Environment

1. Install Docker and docker-compose
2. Navigate to the project directory and run `docker-compose up` to start a Docker container providing Apache/ownCloud/files_duplicate
3. Open http://localhost in our web browser and log in as **admin**/**admin**

[files_duplicate](files_duplicate) will be mounted inside the Docker container as a (read-only) volume allowing you to modify the source code on the fly.
