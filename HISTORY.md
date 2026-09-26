## Version 1.0.2 - TBA

CHG: Updated the extension template to PRADO 4.3.3 (the `prado-4.3` branch); requires PHP 8.1 and `pradosoft/prado` `~4.3.3 || dev-prado-4.3`. (belisoful)  
CHG: Synchronized `.php-cs-fixer.dist.php`, `phpstan.neon.dist` (PRADO PHPStan extensions), the GitHub workflow, LICENSE year, and `AGENTS.md` with PRADO 4.3.3. (belisoful)  
ENH: `MainModule` class docblock documents the XML and PHP module configuration styles. (belisoful)  
ENH: `errorMessages.txt` documents its format and uses the `#` comments supported by PRADO 4.3.3. (belisoful)  
ENH: Unit tests for `MainModule`; the PHPUnit bootstrap constructs a global `TApplication` from `tests/unit/app`. (belisoful)  
ENH: Working Knowledge files under `agents/` (INDEX.md, SUMMARY.md, and class knowledge files). (belisoful)  
BUG: `tests/unit/bootstrap.php` referenced a vendor autoloader outside the project; it now delegates to the project PHPUnit bootstrap. (belisoful)  
BUG: The GitHub workflow created the PostgreSQL database `prado_unitest` instead of `prado_compex_unitest` from `tests/initdb_pgsql.sql`. (belisoful)  

## Version 1.0.1

Initial PRADO 4.2 composer extension example.
