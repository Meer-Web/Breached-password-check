# Password check using k-Anonymity
PHP function for checking passwords against the pwnedpasswords.com database

You can add this function inside your functions file.

k-Anonymity means that it does NOT send your password over the internet but hashes it and only sends a part of the hash to request a list of all hashed passwords which have been compromised. 
You will not send your password over the internet!

For example your password is 'Welcome01'

This will be hashed to: a1a2094820f0313d61da4f44032013eaf6c2b7d3
Only 'a1a20' will be send to the pwnedpasswords.com API which will return a list of ALL passwords which have been compromised where the hash starts with 'a1a20'. 

You then download that list and check if the full hashed password is found it the list.

In case it is found your password is compromised and you can build your site that this password cannot be used or just warn the user.