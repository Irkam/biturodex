package net.orbital_chainsaw.biturodex.classes;

/**
 * Created by jivay on 29/09/14.
 */
public class User {
    protected String username;
    protected String first_name;
    protected String last_name;
    protected String email;
    protected String sesstoken;

    public User(){
    }

    public User(String uname, String fname, String lname, String email, String sesstoken){
        this.username = username;
        this.first_name = fname;
        this.last_name = lname;
        this.email = email;
        this.sesstoken = sesstoken;
    }
}
