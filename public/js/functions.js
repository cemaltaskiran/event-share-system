function validate(){
    var min_age = document.forms["form"]["min_age"].value;
    var max_age = document.forms["form"]["max_age"].value;

    if(max_age > min_age){
        return true;
    }
    return false;
}
