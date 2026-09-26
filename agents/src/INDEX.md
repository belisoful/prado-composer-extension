# src/

### Directories
[project](../INDEX.md) / **`src`**

| Directory | Summary |
|---|---|
| `Pages/` | Extension page templates; `Example.page` places its content into `<com:TContent ID=<%$ PluginContentId %>>`. |

## Purpose
The extension source directory, autoloaded by PSR-4 as the `PradoComposerExtension\` namespace.
`Prado\Util\TPluginModule::getPluginPath()` resolves to this directory (the directory of the
bootstrap module class file), so `Pages/` and `errorMessages.txt` are found relative to it.

## Classes
- [MainModule](MainModule.md) — the composer bootstrap module (`extra.bootstrap`); extends `TPluginModule`
  and adds the example `PropertyA` string property.

## Files
- `errorMessages.txt` — `code = message` lines with `{0}` style placeholders; `#` and `;` comments are
  allowed (PRADO 4.3.3).  `errorMessages-<lang>.txt` is loaded instead when it matches the preferred language.
- `Pages/Example.page` — the example page, served as `?page=Example` through `TPageService::onAdditionalPagePaths`.
