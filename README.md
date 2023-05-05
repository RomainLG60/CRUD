# CRUD

Welcome to the CRUD (Create, Read, Update, Delete) Application! This README will guide you on how to set up and use the application to manage your database.

# Initial Setup
Configure database connection: Open the 'BDD.php' file and update the connection settings to match your database credentials (hostname, username, password, and charset).

Set the database name: Go to 'CRUD/Generique/TableInfos.php' and update the 'cst_dbName' variable to match the name of your database.

# Table Setup
For each table in your database, follow these steps:

Create a table model: Create a new PHP file in the 'CRUD/Tables' folder based on the 'CRUD_TEMPLATES' file. Make sure to update the table name, primary key, and columns to match your database table structure.

Create a table object: Create a new PHP file in the Tables folder named after your table (e.g., 'Table.php'). Use the provided 'Table.php' as a template and update the Table object to match your table model created in the previous step.

Update the Request_to_Object: In the CRUD table file you just created, update the 'Request_to_Object' method to use the correct table object associated with your table.

Update the table object extension: In your table object file, update the class definition to extend the correct table model from the 'CRUD/Tables' folder.

# Usage
Now that your tables are set up, you can use the CRUD application to manage your data. Check out the example login.php file in the Utilitaires folder to see how to interact with the CRUD system. Modify or create new files as needed to fit your requirements.

That's it! You're now ready to use the CRUD application to manage your database. If you have any questions or need further assistance, feel free to reach out.
