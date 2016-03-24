window.onload = function() {
//check todos
//TODO - fix deletion on obj
var counter = 0;
var oldSelectionShapeId = -1;
var newSelectionShapeId = -1;
var oldSelectionIndex = -1;
var newSelectionIndex = -1;
var clearShapesBool = false;
var clearLinesBool = false;
var undoLineBool = false;
var showText = false;
var currType = 'single-link';



document.getElementById('clearshapes').onclick = function() {
  clearShapesBool = true;
};
document.getElementById('clear').onclick = function() {
  clearLinesBool = true;
};

document.getElementById('undo').onclick = function() {
  undoLineBool = true;
};

document.getElementById('gradeMe').onclick = function() {
  var ret = s.shapes.concat(s.lines);

    console.log(ret);

    console.log(maxPointsPossible(ret));
//	console.log();


    // someohow send alexa stuff
    
     //   call grade funtion with data from canvas 1
               var e = document.getElementById('submitArea');
                             e.innerHTML = "Your quiz has been submitted";
                           };
  

document.getElementById('createMe').onclick = function() {
  var ret = s.shapes.concat(s.lines);


   var retToData = JSON.stringify(ret);

                var e = document.getElementById('submitArea');
		var string = "Your quiz has been created" ;
                                   e.innerHTML = string;

	var c = document.getElementById('cid');
	var cid = c.options[c.selectedIndex].value;
	var name = document.getElementById('title').value;
        var q = document.getElementById('q').value;



	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			e.innerHTML += " -- " + xmlhttp.responseText;
		}
	};
	xmlhttp.open("POST", "pushToDatabase.php", true);

var tosend ='data="' + retToData +'"&name="' + name + '"&class="' +cid +'"&q="' +q +'"';
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(tosend);


};


var tpointer = -1;
var tnext = -1;
var tprevious = -1;
var txx = 0;
var tyy = 0;
var tvalues = [];

function Line(id, type, begin, end, fill, x, y, xx, yy) {

  // Input Format Info
  this.id = counter;
  this.type = type;
  this.begin = begin;
  this.end = end;

  // UI Info
  this.x = x;
  this.y = y;
  this.xx = xx;
  this.yy = yy;
  this.fill = fill;
}

function Shape(id, type, pointer, previous, next, value, values, x, y, w, h) {
  // Input Format Info
  this.id = counter;
  this.type = type;
  this.pointer = pointer;
  this.previous = previous;
  this.next = next;
  this.value = value;
  this.values = values;

  // UI info
  this.x = x;
  this.y = y;
  this.w = w;
  this.h = h;
}

// Draws this shape to a given context
//Root arrow single-link double-link value-array pointer-array

Shape.prototype.draw = function(ctx) {
  var width = 50;
  var height = 50;
  var color = '#99ebff';
  if (this.type == 'root') {
    ctx.fillStyle = '#bfbfbf';
    this.id = -1;
  }
  if (this.type == 'single-link') {
    ctx.fillStyle = '#99ebff';
  }
  if (this.type == 'double-link') {
    ctx.fillStyle = '#66ffc2';
  }
  if (this.type == 'value-array') {
    ctx.fillStyle = '#b3b3ff';
    width = 100;
  }
  /*    if(this.type == 'pointer-array'){
       ctx.fillStyle = '#ff99cc';
      var width = 50;
       var height = 50; 
       } */
  ctx.fillRect(this.x, this.y, width, height);
  // text
  ctx.fillStyle = '#000000';
  ctx.font = "12px Arial";
  if (this.type == 'value-array') {
    ctx.fillText(this.values, this.x + (this.w / 4), this.y + (this.h / 4));
  } else {
    ctx.fillText(this.value, this.x + (this.w / 4), this.y + (this.h / 4));
  }
  if (showText) {
    ctx.fillText(this.id, this.x + (this.w / 4), this.y + (this.h / 4) + 10);
    ctx.fillText(this.pointer, this.x + (this.w / 4), this.y + (this.h / 4) + 20);
    ctx.fillText(this.previous, this.x + (this.w / 4), this.y + (this.h / 4) + 30);
    ctx.fillText(this.next, this.x + (this.w / 4), this.y + (this.h / 4) + 40);
  }
}

// Draws this shape to a given context
Line.prototype.draw = function(ctx) {

  ctx.beginPath();
  ctx.moveTo(this.x, this.y);
  ctx.lineTo(this.xx, this.yy, 6);
  ctx.strokeStyle = this.fill;
  ctx.stroke();
  // text
  if (showText) {
    ctx.fillStyle = '#000000';
    ctx.font = "12px Arial";
    ctx.fillText("[" + this.id + "]", this.x, this.y);
    ctx.fillText(this.begin, this.x, this.y + 10);
    ctx.fillText(this.end, this.x, this.y + 20);
  }
}

// Check if mouse point in shape
Shape.prototype.contains = function(mx, my) {
  return (this.x <= mx) && (this.x + this.w >= mx) &&
    (this.y <= my) && (this.y + this.h >= my);
}

function CanvasState(canvas) {
  this.canvas = canvas;
  this.width = canvas.width;
  this.height = canvas.height;
  this.ctx = canvas.getContext('2d');
  // Border padding info
  var stylePaddingLeft, stylePaddingTop, styleBorderLeft, styleBorderTop;
  if (document.defaultView && document.defaultView.getComputedStyle) {
    this.stylePaddingLeft = parseInt(document.defaultView.getComputedStyle(canvas, null)['paddingLeft'], 10) || 0;
    this.stylePaddingTop = parseInt(document.defaultView.getComputedStyle(canvas, null)['paddingTop'], 10) || 0;
    this.styleBorderLeft = parseInt(document.defaultView.getComputedStyle(canvas, null)['borderLeftWidth'], 10) || 0;
    this.styleBorderTop = parseInt(document.defaultView.getComputedStyle(canvas, null)['borderTopWidth'], 10) || 0;
  }

  var html = document.body.parentNode;
  this.htmlTop = html.offsetTop;
  this.htmlLeft = html.offsetLeft;

  this.valid = false; // when set to false, the canvas will redraw everything
  this.shapes = [];
  this.lines = [];
  this.selections = [];
  this.dragging = false;
  this.selection = null;
  this.dragoffx = 0;
  this.dragoffy = 0;

  var myState = this;
  myState.lock = true;

  canvas.addEventListener('selectstart', function(e) {
    e.preventDefault();

    return false;
  }, false);

  canvas.addEventListener('click', function(e) {

    if (!myState.lock && myState.itemSelected) {
      var mouse = myState.getMouse(e);
      var mx = mouse.x;
      var my = mouse.y;

      var lines = myState.lines;

      if (clicks != 1) {
        clicks++;
      } else {
        var lineid = ++counter;

        //Add previous line/arrow
        if (document.getElementById("prevCheck").checked == true) {
          myState.addLine(new Line(lineid, 'arrow', oldSelectionShapeId, newSelectionShapeId, '#FF0000', lastClick[0], lastClick[1], mx, my));

          if (myState.oldSelection.type == 'double-link') {
            myState.oldSelection.previous = lineid;
          }
          if (myState.oldSelection.type == 'double-link') {
            myState.oldSelection.previous = lineid;
          }

        } else {

          myState.addLine(new Line(lineid, 'arrow', oldSelectionShapeId, newSelectionShapeId, '#000000', lastClick[0], lastClick[1], mx, my));

          if (myState.oldSelection.type == 'root') {
            myState.oldSelection.pointer = lineid;
          }
          if (myState.oldSelection.type == 'single-link') {
            myState.oldSelection.next = lineid;
          }
          if (myState.oldSelection.type == 'double-link') {
            myState.oldSelection.next = lineid;
          }
          /*    if(this.type == 'pointer-array'){
               ctx.fillStyle = '#ff99cc';
              var width = 50;
               var height = 50; 
               } */

        }
        clicks = 0;
      }
      lastClick = [mx, my];
    }
  }, false);
  myState.itemSelected = false;
  //todo: check if that and other variables are used 

  canvas.addEventListener('mousedown', function(e) {
    myState.oldSelection = myState.selection;
    var mouse = myState.getMouse(e);
    var mx = mouse.x;
    var my = mouse.y;
    var shapes = myState.shapes;
    var l = shapes.length;
    for (var i = l - 1; i >= 0; i--) {
      if (shapes[i].contains(mx, my)) {
        var mySel = shapes[i];
        myState.dragoffx = mx - mySel.x;
        myState.dragoffy = my - mySel.y;
        myState.dragging = true && myState.lock;
        myState.selection = mySel;
        myState.selectionIndex = i;
        myState.valid = false;
        myState.itemSelected = true;
        if (clicks != 1) {

          oldSelectionShapeId = myState.selection.id;
          oldSelctionIndex = i;
        } else {
          newSelectionShapeId = myState.selection.id;
          newSelctionIndex = myState.selectionIndex;
        }
        return;
      }
    }
    // If no return, no seletion
    // If there was an object selected, we deselect it
    if (myState.selection) {
      myState.selection = null;
      myState.valid = false;
      myState.itemSelected = false;
    }
  }, true);
  canvas.addEventListener('mousemove', function(e) {
    if (clearShapesBool) {
      myState.clearShapes();
      clearShapesBool = false;
    }
    if (clearLinesBool) {
      myState.clearLines();
      clearLinesBool = false;
    }
    if (undoLineBool) {
      myState.popLine();
      undoLineBool = false;
    }

    if (myState.dragging) {
      var mouse = myState.getMouse(e);
      // drag using the offset of mouse click
      myState.selection.x = mouse.x - myState.dragoffx;
      myState.selection.y = mouse.y - myState.dragoffy;
      myState.valid = false;
    }
  }, true);
  canvas.addEventListener('mouseup', function(e) {
    myState.dragging = false;
  }, true);

  window.addEventListener('keydown', function(e) {

    if (e.keyCode == 20) { // press capslock to toggle between modes
      // todo: add text displaying modes
      myState.lock = !myState.lock;
      if(myState.lock) {
         document.getElementById("lock").innerHTML = "Mode: Object Mode";
      } else {
         document.getElementById("lock").innerHTML = "Mode: Arrow Mode ****************";
      }
      clicks = 0;
    }
  }, false);

  window.addEventListener('keypress', function(e) {
    //Root arrow single-link double-link value-array pointer-array

    if (e.keyCode == 33) { // press shift 1 for root
      currType = 'root';
    }
    if (e.keyCode == 64) { // press shift 2 for single-link
      currType = 'single-link';
    }
    if (e.keyCode == 35) { // press shift 3 for double-link
      currType = 'double-link';
    }
    if (e.keyCode == 36) { // press shift 4 for value-array
      currType = 'value-array';
    }
    /* if (e.keyCode == 37) { // press shift 5 for pointer-array
       currType = 'pointer-array';
     } */
  }, false);

  // double click to add objects
  canvas.addEventListener('dblclick', function(e) {
    var mouse = myState.getMouse(e);
    counter++;

    if (currType == 'root') {
      myState.addShape(new Shape(-1, currType, tpointer, tprevious, tnext, "root", tvalues, mouse.x - 10, mouse.y - 10, 50, 50));
    }
    if (currType == 'single-link') {
      myState.addShape(new Shape(counter, currType, tpointer, tprevious, tnext, document.getElementById("text").value, tvalues, mouse.x - 10, mouse.y - 10, 50, 50));
    }
    if (currType == 'double-link') {
      myState.addShape(new Shape(counter, currType, tpointer, tprevious, tnext, document.getElementById("text").value, tvalues, mouse.x - 10, mouse.y - 10, 50, 50));
    }
    if (currType == 'value-array') {
      myState.addShape(new Shape(counter, currType, tpointer, tprevious, tnext, "NULL", [document.getElementById("val1").value, document.getElementById("val2").value, document.getElementById("val3").value, document.getElementById("val4").value], mouse.x - 10, mouse.y - 10, 100, 50));
    }
    /*    if(this.type == 'pointer-array'){
    // todo: add pointer array functionality
         } */

  }, true);

  // right click to remove objects
  canvas.addEventListener('contextmenu', function(e) {
    var shapeToRemoveId = myState.selection.id;
    var tempShapes = [];
    var l = myState.shapes.length;
    for (var i = 0; i < l; i++) {
      var shape = myState.shapes[i];
      if (shape.id != shapeToRemoveId) {
        tempShapes.push(shape);
      }
    }
    
     var arrows = [];
    var ll = myState.lines.length;
    for (var ii = 0; ii < ll; ii++) {
      if (myState.lines[ii].begin == shapeToRemoveId || myState.lines[ii].end == shapeToRemoveId) {
        arrows.push(myState.lines[ii]);
      }
    }
    myState.removeObjConnections(arrows);
    
    myState.selection = null;
    myState.shapes = tempShapes;
    myState.valid = false;
  }, true);


  this.selectionColor = '#CC0000';
  this.selectionWidth = 2;
  this.interval = 30;
  setInterval(function() {
    myState.draw();
  }, myState.interval);
}

CanvasState.prototype.addShape = function(shape) {
  this.shapes.push(shape);
  this.valid = false;
}

CanvasState.prototype.clearShapes = function() {
  this.shapes = [];
  this.lines = [];
 //TODOOOOOO
  this.valid = false;
}

CanvasState.prototype.popLine = function() {
 var arrowId = this.lines[this.lines.length - 1].id;
  var beginId = this.lines[this.lines.length - 1].begin;
  this.lines.pop();
  // make shape connection nulll (-1) 
  var l = this.shapes.length;
  for (var i = 0; i < l; i++) {
    var shape = this.shapes[i];
    if (shape.id == beginId) {
      if (shape.pointer == arrowId) {
        shape.pointer = -1;
      }
      if (shape.previous == arrowId) {
        shape.previous = -1;
      }
      if (shape.next == arrowId) {
        shape.next = -1;
      }
    }
  }
  this.valid = false;
}

CanvasState.prototype.removeObjConnections = function(arrows) {
  for (var j = 0; j < arrows.length; j++) {
    var arrowId = arrows[j].id;
    var beginId = arrows[j].begin;
    this.lines.pop();
    // make shape connection nulll (-1) 
    var l = this.shapes.length;
    for (var i = 0; i < l; i++) {
      var shape = this.shapes[i];
      if (shape.id == beginId) {
        if (shape.pointer == arrowId) {
          shape.pointer = -1;
        }
        if (shape.previous == arrowId) {
          shape.previous = -1;
        }
        if (shape.next == arrowId) {
          shape.next = -1;
        }
      }
    }
  }
  this.valid = false;
}

CanvasState.prototype.addLine = function(line) {
  this.lines.push(line);
  this.valid = false;
}

CanvasState.prototype.clearLines = function() {
  this.lines = [];
    // clear all connections from shapes
  var l = this.shapes.length;
  for (var i = 0; i < l; i++) {
    var shape = this.shapes[i];
    shape.pointer = -1;
    shape.previous = -1;
    shape.next = -1;
  }
  this.valid = false;
}

CanvasState.prototype.clear = function() {
  this.ctx.clearRect(0, 0, this.width, this.height);
}

CanvasState.prototype.draw = function() {
  // only redraw whem state not valid
  if (!this.valid) {
    var ctx = this.ctx;
    var shapes = this.shapes;
    var lines = this.lines;

    this.clear();

    // draw all shapes
    var l = shapes.length;
    for (var i = 0; i < l; i++) {
      shapes[i].draw(ctx);
    }

    // draw all lines
    var ll = lines.length;
    for (var ii = 0; ii < ll; ii++) {
      /*  todo: see if lines can move with objects
        lines[ii].x = shapes[lines[ii].arrbegin].x;
        lines[ii].y = shapes[lines[ii].arrbegin].y;
        lines[ii].xx = shapes[lines[ii].arrend].x;
        lines[ii].yy = shapes[lines[ii].arrend].y;
        */
      lines[ii].draw(ctx);
    }

    // draw selection
    if (this.selection != null) {
      ctx.strokeStyle = this.selectionColor;
      ctx.lineWidth = this.selectionWidth;
      var mySel = this.selection;
      ctx.strokeRect(mySel.x, mySel.y, mySel.w, mySel.h);
    }

    this.valid = true;
  }
}


// Get mouse position relative to the canvas
CanvasState.prototype.getMouse = function(e) {
  var element = this.canvas,
    offsetX = 0,
    offsetY = 0,
    mx, my;

  // Compute the total offset
  if (element.offsetParent !== undefined) {
    do {
      offsetX += element.offsetLeft;
      offsetY += element.offsetTop;
    } while ((element = element.offsetParent));
  }

  // Add padding and border style widths to offset
  // Also add the <html> offsets in case there's a position:fixed bar
  offsetX += this.stylePaddingLeft + this.styleBorderLeft + this.htmlLeft;
  offsetY += this.stylePaddingTop + this.styleBorderTop + this.htmlTop;

  mx = e.pageX - offsetX;
  my = e.pageY - offsetY;

  return {
    x: mx,
    y: my
  };
}

var clicks = 0;
var lastClick = [0, 0];
var oldSelectionSet = false;

var s = new CanvasState(document.getElementById('canvas1'));





};
