# Referral plugin : 
### Powerfull plugin who adding complete referral system to Azuriom 

This plugin allow you to create a real referral system : All players can invite their friends to register them in your website with his link or simply add his nickname after registration. After, you can choice, for example, to give a percentage to the referrer when one of his referred bought anything in the shop (Only works with money of the website !).

At this time, only regive a percentage of money is available, but i can add a lot of rewards in the future : 

- Executed commands in game server
- Giftcards
- Discount cards
- Exclusive money system
- and more... 

## Complete Overview : 

Firsly, you need the plugin [Shop](https://market.azuriom.com/resources/1), and articles buyable with the site money (if u want to regive a percentage to referrers). 

----

New players can register a referrer by two ways :

> When a new player register themself, it will be redirect in a page who ask him to set the nickname of a referrer if him wants. As an administrator, you can if you want choice, in settings, to add a limit of time between the register  of the player and the moment when the player register his referrer.

> All players have a referrer link, like `https://yourwebsite.yourdomain/from/nickname`. When a new player use it for go in your website, it automatically register the nickname contain in the link in a cookie. If he register a new account, the user with the given nickname in cookie will be automatically set as a referrer. The link can be copied in profile page, and the link of someone can be copied in the user edit page, on admin panel.

However if the player cannot register his referrer just after his registration, an admin can edit the referrer of someone at any time, or he can register it manually if you enable it, with link `https://yourwebsite.yourdomain/referral/register`.

So, after referrer registration (or no :p), all players can see their referrer profile directly in the profile page. The player can see the nickname of his referrer, how much money the referrer win thanks to him, the list of all referred players (and how much he win thanks to them, the date of the referral and if the referral was created by the referrer link or no). Finally, players can copy their referrer links.

When a player bought anything in the shop, if he has a referrer and if you have enable the redistribution of a percentage of amouunt, the referrer will receive this percentage of the amount directly. ⚠️ Caution : Avoid decimal use in price of orders. It can create duplication issue due to regive amount rounded ⚠️

That's all for the players.

----

For admin side now : You can globally change the settings of anything u want. U can also regenerate the tables of referral system (if u have issue of bots for example, for season reset or anything u want). You can see all rewards given by the referral system in details, modify the settings of all the rewards, and soon see all the statistics of the referral system, for help you to find a good communication strategy for example.

You can also edit the referrer of all players, and see all statistics of a specific player (referrer, referreds, rewards given and rewards receive).

----

For the permissions, you have the permission to manage the plugin (edit settings), and permission to regenerate the tables of plugin (please give it only to trust people)

----

## Bug traking, request for add anything, question or another issue :

#### You can contact me directly in my discord server : https://discord.gg/yFpkrwebnQ. Dont hesitate to contact me for anything, i'm happy to help u !

----

Also if you want to help me for translate the plugin in another language who is not supported at this time or correct a translation, dont hesitate to join the discord too and dm me.

----

## API Documentation :

For developers who want an API for implements a great system to their servers dont worries, the API will be added in a next version, and will allow you to :

- Have all datas you need concerning referrals
- Interact directly with referrals datas
