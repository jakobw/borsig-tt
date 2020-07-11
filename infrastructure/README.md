# Infrastructure

## Setup up from scratch
`ansible-playbook setup.yml --limit [HOST]`

## Restore backup
* site must be up and running
* `ansible-playbook restore_from_backup.yml -e 'backup_file=path/to/local/backup.sql' --limit [HOST]`
