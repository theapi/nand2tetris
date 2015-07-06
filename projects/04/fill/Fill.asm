// This file is part of www.nand2tetris.org
// and the book "The Elements of Computing Systems"
// by Nisan and Schocken, MIT Press.
// File name: projects/04/Fill.asm

// Runs an infinite loop that listens to the keyboard input. 
// When a key is pressed (any key), the program blackens the screen,
// i.e. writes "black" in every pixel. When no key is pressed, the
// program clears the screen, i.e. writes "white" in every pixel.

// Two states: CLEARSCREEN & FILLSCREEN whilst in either state, 
// monitor the keyboard and change to the other state when needed.
// 
// 
// 
// (CLEARSCREEN)
  // @i = number of 16 bit registers in the screen map
  // @SCREEN // set A to the first screen register
  // (CLEARLOOP)
    // (if @i > 0) {
      // set value of A to -1
      // A=A+1
      // @i--
      // 
    // }
    // 
  // (CLEARKBDLOOP)
    // if (@KBD > 0) {
      // jump to FILLSCREEN
    // }
// 
    // 
// (FILLSCREEN)
  // @i = number of 16 bit registers in the screen map 
  // @SCREEN // set A to the first screen register
  // (FILLLOOP)
    // (if @i > 0) {
      // set value of A to -1
      // A=A+1
      // @i--
      // 
    // }
    // 
  // (FILLKBDLOOP)
    // if (@KBD == 0) {
      // jump to CLEARSCREEN
    // }
    

(CLEARSCREEN)
  // 256 rows of 32 registers, so 8192 registers
  // Store 8192 in @i
  @8192
  D=A
  @count
  M=D
  
  @SCREEN // set A to the first screen register
  D=A  // store the location of the first screen register in D
  @i   // a variable to keep track of the screen register index
  M=D  // store the address of the first screen register in @i
  
  (CLEARLOOP)
    @i // load the next register to be filled
    D=M
    A=D // Set the current register to the value of D
    
    M=0  // fill with white
    
    @i
    M=M+1 // increment the index
    
    @count
    MD=M-1 // decrement the count & set D for comparison
    @CLEARLOOP // Get the address of the loop
    D;JGT // If @count > 0 then goto CLEARLOOP
    
  // Monitor the keyboard
  (CLEARKBDLOOP)
    @KBD
    D=M
    @CLEARKBDLOOP
    D;JEQ // If @KBD == 0 then goto CLEARKBDLOOP
  
  @FILLSCREEN
  0;JMP // jump to FILLSCREEN as a key is pressed
  
  
(FILLSCREEN)
  // 256 rows of 32 registers, so 8192 registers
  // Store 8192 in @i
  @8192
  D=A
  @count
  M=D
  
  @SCREEN // set A to the first screen register
  D=A  // store the location of the first screen register in D
  @i   // a variable to keep track of the screen register index
  M=D  // store the address of the first screen register in @i
  
  (FILLLOOP)
    @i // load the next register to be filled
    D=M
    A=D // Set the current register to the value of D
    
    M=-1  // fill with black
    
    @i
    M=M+1 // increment the index
    
    @count
    MD=M-1 // decrement the count & set D for comparison
    @FILLLOOP // Get the address of the loop
    D;JGT // If @count > 0 then goto FILLLOOP
    
  // Monitor the keyboard
  (FILLKBDLOOP)
    @KBD
    D=M
    @FILLKBDLOOP
    D;JGT // If @KBD >= 0 then goto FILLKBDLOOP
  
  @CLEARSCREEN
  0;JMP // jump to CLEARSCREEN as no key is pressed
  

(END)
  @END // get ready to jump to here
  0;JMP // Infinite loop
















