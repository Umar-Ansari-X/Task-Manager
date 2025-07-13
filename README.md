# 🗓️ Task-Manager
A  web calendar that lets people add colour-coded tasks, edit them in-place and see their whole week at a glance.

**Images:** 
![Login Screenshot](images/)
![Cards Screenshot](images/)

---

## How It’s Made

**Used:** HTML, CSS, PHP, MySQL

* **Frontend** – a lightweight calendar written just in normal CSS and HTML with cards representing days features for customization
* **Backend** – REST-style JSON endpoints in PHP (`add_event.php`, `update_event.php`, `tasks.php` etc) handle CRUD 
* **Database** – three tables (`users`, `events`, `card_colors`) and events are pre-fetched ± 2 years around today for ease of use
* **Auth** – session-based login / sign-up with hashed passwords

---


## Lessons Learned 

* Treating *state* as a single-source-of-truth JSON blob simplified both client & server code.  
* Small UI features can bring a lot to the table such as adding the colour customizations to each card
* An intro on user sign-ins and logins


---


## Getting Started

```bash
git clone https://github.com/Umar-Ansari-X/Task-Manager.git
cd Task-Manager/task_manager_web

# create DB & import schema find task_manager.sql then import it
```
