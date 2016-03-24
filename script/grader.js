"use strict";
function gradeMe() { 
   var canvas = document.getElementById('canvas1');
//   call grade funtion with data from canvas 1
      console.log("you are here");
         var e = document.getElementById('submitArea');
                 e.innerHTML = "Your quiz has been submitted for grading";
}
function createMe() {
   var canvas = document.getElementById('canvas1');
//   call grade funtion with data from canvas 1
          var e = document.getElementById('submitArea');
              e.innerHTML = "Your quiz has been created";
   } 

var gradedA = [];
var gradedB = [];

function goodPointers(a, b) {
    /*// What is good coding?
    if (a === -1 && b === -1) {
        return true;
    } else if (a === -1 || b === -1) {
        return false;
    } else {
        return true;
    }*/
    return a !== -1 && b !== -1;
}

function convertObjectIntoGradable(obj) {
    //var obj = JSON.parse(str).objects;
    var gradable = {};
    gradable[-1] = {"type" : "none"};
    for (var i = 0; i < obj.length; ++i) {
        var o = obj[i];
        if (o.type === "root") {
            gradable[-1] = o;
        } else {
            gradable[o.id] = o;
        }
    }
    return gradable;
}

function gradeRoot(a, b) {
    var ret = 1;
    if (!goodPointers(a.pointer, b.pointer)) {
        --ret;
    }
    return ret;
}

function gradeArrow(a, b) {
    /*var ret = 0;
    if (goodPointers(a.begin, b.begin)) {
        ++ret;
    }
    if (goodPointers(a.end, b.end)) {
        ++ret;
    }
    return ret;*/
    return 0;
}

function gradeSingleLink(a, b) {
    var ret = 1;
    if (a.value !== b.value) {
        --ret;
    }
    /*if (goodPointers(a.next, b.next)) {
        ++ret;
    }*/
    return ret;
}

function gradeDoubleLink(a, b) {
    var ret = 1;
    if (a.value !== b.value) {
        --ret;
    }
    /*if (goodPointers(a.previous, b.previous)) {
        ++ret;
    }
    if (goodPointers(a.next, b.next)) {
        ++ret;
    }*/
    return ret;
}

function gradeValueArray(a, b) {
    var ret = 0;
    if (a.values.length === b.values.length) {
        ret = a.values.length;
        for (var i = 0; i < a.values.length; ++i) {
            if (a.values[i] !== b.values[i]) {
                --ret;
            }
        }
    }
    return ret;
}

function gradePointerArray(a, b) {
    /*var ret = 0;
    if (a.values.length === b.values.length) {
        for (var i = 0; i < a.values.length; ++i) {
            if (goodPointers(a.values[i], b.values[i])) {
                ++ret;
            }
        }
    }
    return ret;*/
    return 0; // TODO ????
}

function gradeCurrent(aObject, aCurrent, bObject, bCurrent) {
    var a = aObject[aCurrent];
    var b = bObject[bCurrent];
    
    //console.log("Evaluating: " + a.id + " and " + b.id);
    var ret = 0;
    
    if (gradedA.indexOf(a.id) === -1 && gradedB.indexOf(b.id) === -1) {
        
        //console.log("Grading: " + a.id + " and " + b.id);
        
        gradedA.push(a.id);
        gradedB.push(b.id);
        if (a.type === b.type && a.type === "root") {  
            ret += gradeRoot(a, b);
            if (goodPointers(a.pointer, b.pointer)) {
                ret += gradeCurrent(aObject, a.pointer, bObject, b.pointer);
            }
        } else if (a.type === b.type && a.type === "arrow") {
            ret += gradeArrow(a, b);
            if (goodPointers(a.begin, b.begin)) {
                ret += gradeCurrent(aObject, a.begin, bObject, b.begin);
            }
            if (goodPointers(a.end, b.end)) {
                ret += gradeCurrent(aObject, a.end, bObject, b.end);
            }
        } else if (a.type === b.type && a.type === "single-link") {
            ret += gradeSingleLink(a, b);
            if (goodPointers(a.next, b.next)) {
                ret += gradeCurrent(aObject, a.next, bObject, b.next);
            }
        } else if (a.type === b.type && a.type === "double-link") {
            ret += gradeDoubleLink(a, b);
            if (goodPointers(a.previous, b.previous)) {
                ret += gradeCurrent(aObject, a.previous, bObject, b.previous);
            }
            if (goodPointers(a.next, b.next)) {
                ret += gradeCurrent(aObject, a.next, bObject, b.next);
            }
        } else if (a.type === b.type && a.type === "value-array") {
            ret += gradeValueArray(a, b);
        } else if (a.type === b.type && a.type === "pointer-array") {
            var initial = gradePointerArray(a, b);
            if (initial !== 0) {
                for (var i = 0; i < a.values.length; ++i) {
                    if (goodPointers(a.values[i], b.values[i])) {
                        initial += gradeCurrent(aObject, a.values[i], bObject, b.values[i]);
                    }
                }
            }
            ret += initial;
        }
    }
    return Math.max(ret, 0);
}

// Pass objects here (the "objects" array of the container)
function gradeAnswer(solution, answer) {
    gradedA = [];
    gradedB = [];
    var a = convertObjectIntoGradable(solution);
    var b = convertObjectIntoGradable(answer);
    return gradeCurrent(a, -1, b, -1);
}

function maxPointsPossible(solution) {
    return gradeAnswer(solution, solution);
}
