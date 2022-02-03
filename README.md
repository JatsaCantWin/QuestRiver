# QuestRiver

QuestRiver is an RPG-themed motivational app that keeps track of your dailies, todos, future goals and more, helping motivate you to maintain good habits.

Create your character and slay monsters (bad habits), do quests (todo list) or hone your skills (hobbies) to earn xp and money that you can exchange for virtual rewards or permission to reward yourself in real life.

How to build:
Create a PostgresSQL database with provided .sql file
Create a config.php file in the main directory with the following content:

    <?php
    const USERNAME = yourUsername;
    const PASSWORD = yourPassword;
    const HOST = hostAdress;
    const DATABASE = databaseName;
    const COOKIE_LIFETIME = 86400;
    to configure your connection
    Build a docker container with provided docker-compose file and run it.

# How to use:
As of right now, the app has three main views:
Login, where you can create or access your account
Statistics, where you can see your character's stats and skills
Quests, where you can take up daily quests

On the statistics screen you can see a section for your skills: you should input your real life skills like singing or cooking, and click the plus sign each time you practice them - you will be rewarded with a small amount of xp

On the quest screen you should input your daily todo list into the quest section. Click the checkbox to check your todo off, you will be rewarded with some XP. If you fail to do your daily, you will lose some health points.

If your character dies, you lose 1 level and can't level up your attribute until you regain lost levels.