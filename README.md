# Description
A multiplexor middleware for given command implementation (`Cmd` class), which
is intended to store command object state over requests. No database, no file,
no memcache - just an object with its state.

# Installation
See `INSTALL.md` for installation instructions.

# Usage
1. `cd` to the current directory.
2. Start PHP built-in server by running
```
php -S localhost:8080
```
3. Start another PHP built-in server by running
```
php -S localhost:8081
```
4. Start as many PHP built-in servers as you like with any free ports you desire.
5. Open the page in browser with corresponding URL and `cmd<some number>` appended.
  For example, open [http://localhost:8080/cmd1](http://localhost:8080/cmd1). No path is considered as `cmd0`.
6. Update the page. See? The counter is incremented.
7. Open the corresponding page for another started server - but for the same `cmd`.
  For example, open [http://localhost:8081/cmd1](http://localhost:8081/cmd1).
8. See? The state is persistent.
