# Digitalservice
---
# Features
- MySQL database connection
- Secure config handling
- `.gitignore` included
---

# Project Structure
```txt
digitalservice/
├── www.domain.com
├── blog
├── register
├── login
├── reset-password
├── .gitignore
├── uploads/
├── logs/
```
---

# Setup
## Clone Repository
```bash
git clone git@github.com:bittuvwxyz/digitalservice.git
cd digitalservice
```
---
# Create `.env`
```env
DB_HOST=localhost
DB_NAME=testdb
DB_USER=root
DB_PASS=Test@321654
```
---

---
# `.gitignore`
```gitignore
/vendor/
/node_modules/
/config/
```
---
---
# Git Commands
```bash
echo "# digitalservice" >> README.md
git init
git add .
git commit -m "blog"
git branch -M main
git remote add origin git@github.com:bittuvwxyz/digitalservice.git
git push -u origin main
```
---
# Important Notes
- Keep database credentials private
---

# License
MIT
This is use for open source and if anyone wants to contribute please do.