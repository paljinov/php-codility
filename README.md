# php-codility

PHP solutions to **Codility Limited**: https://codility.com/ tasks from their lessons and challenges.  

Codility lessons: https://codility.com/programmers/lessons/  
Codility challenges: https://codility.com/programmers/challenges/  

# Introduction
All tasks are **Codility Limited** ownership. This repository represents my solutions to **Codility Limited** algorithmic tasks. The plan is to solve easier tasks first, and gradually solve all, even the hardest tasks at last. All tasks are considered completed only when when their performance is optimal, at best possible big O time and space complexity.

# Directory structure example
<pre>
src/Lesson x - Lesson name  # Folder for certain lesson
    Solution1.php       # Task1 solution
    Solution2.php       # Task2 solution
    Solution3.php       # Task3 solution
    Lesson.pdf          # Lesson PDF, learn algorithmic basic required to solve tasks
</pre>

Every solution has description according to this example:
```php
/*
 * CODILITY ANALYSIS: https://codility.com/demo/results/demoQV2PE9-UDK/
 * LEVEL: EASY
 * Correctness:	100%
 * Performance:	100%
 * Task score:	100%
 */
function solution($A)
{
    // ... some php code
}
```

# Contribution
Feel free to fork this repository and solve something in better, i.e. more optimal way.

**php-codility** is dockerized for everyone who prefers to debug in the browser instead of in the console.

If you have docker installed:

1. Pull php-codility project
2. Open console and change directory to project root
3. Run the following command:
```sh
docker-compose up -d
```
4. Now you can open any task in your favorite browser, e.g.
```
http://localhost/src/Lesson%2001%20-%20Iterations/BinaryGap.php
```
5. If you need to enter a running container:
```sh
docker exec -it php-codility_app_1 /bin/bash
```

# Copyright and License

According to the [Codility Programmer Terms of Service](https://codility.com/terms-of-service-for-programmers/) **section 8.2.** it is allowed to publish, share and reproduce training section, training tasks and past challenges, their solutions and assessment results.

---
> 8\. Confidentiality

> 8.1. Any Task, statement or information on the Site (including Tests Sessions and Test Session results) is confidential information. You agree not to:

> (a) disclose, publish or reproduce (including posting on any webpage or blog) such information; or

> (b) disclose to others details of a recruitment Task, ongoing Challenge or ongoing competition Task (including details relating to its completion).

> **8.2. This clause does not apply to: Training section of Codility service, Training Tasks and Past Challenges, their solutions and assessment results**.

---

Copyright (c) 2015 - 2019 Pave Aljinović  
Licensed under the [MIT License](docs/LICENSE.md)
