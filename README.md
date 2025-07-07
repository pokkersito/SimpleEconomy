# SimpleEconomy

**SimpleEconomy** is a lightweight and efficient economy plugin for **PocketMine-MP 5**.  
It offers essential features for managing player balances with a simple file-based system — no external database required.

Perfect for survival, factions, or mini-game servers that need a fast and reliable economy system.

---

## 📌 Features

- `/money` — View your current balance  
- `/pay <player> <amount>` — Send money to other players  
- `/topmoney` — Show the top 10 richest players  
- Configurable prefix and messages via `config.yml`  
- Data stored in JSON format (no MySQL required)  

---

## ⚙️ Configuration

All messages and the plugin prefix can be customized in the `config.yml` file.

Example:
```yaml
prefix: "&7[&6SimpleEconomy&7] &f» "
