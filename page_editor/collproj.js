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



function createFirepad( editorInst, options ){
    
    var defaults = {
        firepadId: 0,
        hash: "f2882c2c7c2bd368c7f2366dfeb4504fe02067e9",
        beforeCreated: undefined,
        afterCreated: undefined
    };

    options = $.extend( defaults, options || {});
    
    if ( typeof options.beforeCreated === "function" )
        options.beforeCreated();
    
    
    if ( firepads[options.firepadId] === null ){
        connectFirebase();
        
        var defaultText = editorInst.session.getValue();
        editorInst.session.setValue("");
        
        var node = (options.firepadId === 0) ? "js" : "ss";
        
        var firepad = Firepad.fromACE(firebaseApp.database().ref(options.hash).child(node), 
                                      editorInst,
                                     {defaultText: defaultText});
        
        //$('a.powered-by-firepad').remove();

        firepad.on('ready', function() {
            if ( typeof options.afterCreated === "function" )
                options.afterCreated();
        });

        firepads[options.firepadId] = firepad;
        
        return true;
    }
    else
        return false;
}

function destoryFirepad( firepadId, callback ) {
    if( typeof firepads[firepadId] !== "object" || firepads[firepadId] === null )
        return false;
    
    firepads[firepadId].dispose();
    firepads[firepadId] = null;
    
    if ( typeof callback === "function" )
        callback();
    
    if( firepads[0] === null && firepads[1] === null )
        disconnectFirebase();
}

function hasFirepadCreated( firepadId ) {
    if( (typeof firepads[firepadId] === "object") && (firepads[firepadId] !== null) )
        return true;
    else
        return false;
}


function connectFirebase(){
    if( firebaseApp === null)
        initFirebase();
}
function disconnectFirebase(){
    firebase.database().goOffline();
    firebaseApp.delete();
    firebaseApp = null;
}