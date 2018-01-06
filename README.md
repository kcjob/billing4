# billing4
New Version of billing script.

Billing3 violate the following principles:
1. Separation of concerns and
2. Each function has one and only one task

So each of the following classes has a method does one thing:  
DBConnect -- creates a connection to the database  
UserNamesDAO -- returns an array of the users name   
EquipmentUseDAO -- Returns an object with equipment use details  
EquipmentUseDetails -- an object to hold the details od equipment use  
EmailMessageGenerator -- generates the email to user; invoices are attached   
EmailMessageSender -- sends email to user   
TemplateView -- useremail template   


