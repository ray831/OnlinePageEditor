var firepads = new Array(null, null),
    firebaseApp = null;

// Initialize Firebase
function initFirebase(){
    var config = {
        apiKey: "AIzaSyCpv-L6uU3IUkIFPMyVmaqwFidauXgV_EQ",
        authDomain: "colledit-34fd6.firebaseapp.com",
        databaseURL: "https://colledit-34fd6.firebaseio.com"
    };
    firebaseApp = firebase.initializeApp(config);
}
function destoryFirebase(callback){
    if( firepads[0] === null && firepads[1] === null ){
        
        disconnectFirebase(function(){
            firebaseApp.database().goOffline();
            firebaseApp.delete();
            firebaseApp = null;
        });
        if( typeof callback === "function" )
            callback();
    }
}

function isCollDbSignIn(){
    if( firebaseApp === null )
        return false;
    
    return firebaseApp.auth().currentUser !== null;
}

function connectFirebase(success, error){
    var success = (typeof success === "function") ? success : console.log,
        error = (typeof success === "function") ? success : console.log;
    
    if( firebaseApp === null ){
        error("尚未初始化");
        return false;
    }
    if( isCollDbSignIn() ){
        error("已登入");
        return false;
    }
    
    var email = "fbpmuse@gmail.com",
        pw = "testfirepad";
    firebaseApp.auth()
        .signInWithEmailAndPassword(email, pw)
        .then(function(){success("登入成功");})
        .catch(function(error) {
            console.log("Connection Fail：" + error.code + "：" + error.message);
    });
    
    /*
    firebaseApp.auth().signInAnonymously().catch(function(error) {
        console.log("Connection Fail：" + error.code + "：" + error.message);
    });
    */
}
function disconnectFirebase(success, error){
    firebaseApp.auth().signOut().then(function() {
        if ( typeof success === "function" )
            success();
    }, function(err) {
        if ( typeof error === "function" )
            error(err);
    });
}

//setTimeout(fn, 5000)

function createFirepad( editorInst, options ){
    
    var defaults = {
        firepadId: 0,
        hash: "f2882c2c7c2bd368c7f2366dfeb4504fe02067e9",
        beforeCreated: undefined,
        afterCreated: undefined,
        error: undefined
    };

    options = $.extend( defaults, options || {});
    
    if( !isCollDbSignIn() ){
        if ( typeof options.error === "function" )
            options.error("尚未連接至協作編輯資料庫");
        return false;
    }
    
    if ( typeof options.beforeCreated === "function" )
        options.beforeCreated();
    
    
    if ( firepads[options.firepadId] === null ){
        
        var defaultText = editorInst.session.getValue();
        editorInst.session.setValue("");
        
        var node = (options.firepadId === 0) ? "js" : "ss";
        
        var firepad = Firepad.fromACE(firebaseApp.database().ref(options.hash).child(node), 
                                      editorInst,
                                     {defaultText: defaultText});
        
        // firepad logo
        //$('a.powered-by-firepad').remove();

        firepad.on('ready', function() {
            if ( typeof options.afterCreated === "function" )
                options.afterCreated();
        });

        firepads[options.firepadId] = firepad;
        
        return true;
    }
    else {
        if ( typeof options.error === "function" )
            options.error("協作編輯已就緒");
        return false;
    }
}

function destoryFirepad( firepadId, callback ) {
    if( typeof firepads[firepadId] !== "object" )
        return false;
    
    firepads[firepadId].dispose();
    firepads[firepadId] = null;
    
    if ( typeof callback === "function" )
        callback();
}

function hasFirepadCreated( firepadId ) {
    if( (typeof firepads[firepadId] === "object") && (firepads[firepadId] !== null) )
        return true;
    else
        return false;
}

