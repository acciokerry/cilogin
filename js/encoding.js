function encoding(param){
    param = param.replace(' ', '%20');
    param = param.replace('!', '%21');
    param = param.replace('"', '%22');
    param = param.replace('#', '%23');
    param = param.replace('$', '%24');
    //param = param.replace('%', '%25');
    param = param.replace('&', '%26');
    param = param.replace('\'', '%27');
    param = param.replace('(', '%28');
    param = param.replace(')', '%29');
    param = param.replace('*', '%2A');
    param = param.replace('+', '%2B');
    param = param.replace(',', '%2C');
    param = param.replace('-', '%2D');
    param = param.replace('.', '%2E');
    param = param.replace('/', '%2F');
    param = param.replace(':', '%3A');
    param = param.replace(';', '%3B');
    param = param.replace('<', '%3C');
    param = param.replace('=', '%3D');
    param = param.replace('>', '%3E');
    param = param.replace('?', '%3F');
    param = param.replace('@', '%40');
    param = param.replace('\\', '%5C');
    param = param.replace('[', '%5B');
    param = param.replace(']', '%5D');
    param = param.replace('^', '%5E');

    return param;
}