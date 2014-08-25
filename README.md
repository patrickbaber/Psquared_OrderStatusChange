Psquared_OrderStatusChange
==========================

A small helper extension for adding a new status change event to the Magento environment. With this extension you have the possibility to hook into a new event called "sales_order_status_change" which will be fired after all kinds of order status changes. In addition you have specific events which will be fired only if one status like "pending" changes to another status like "complete". The syntax for these events is really easy:

sales_order_status_change_PREVSTATUS_to_CURRENTSTATUS, e.g. sales_order_status_change_pending_to_complete

This extension is based on this post (http://www.cartware.de/blog/detail/article/kein-magento-event-fuer-statusaenderung/) which describs event driven way to realise a status change event without any rewrites. So, no trouble with rewrite conflicts!
