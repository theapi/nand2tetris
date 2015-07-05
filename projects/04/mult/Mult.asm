// Multiplies R0 and R1 and stores the result in R2.
// (R0, R1, R2 refer to RAM[0], RAM[1], and RAM[2], respectively.)

  @R2 // location of memory holding the running total
  M=0 // initialise result & current data to zero
 
  @R1 // the location of the iteration value
  D=M // Set data to be that of R1, ready for the loop comparison
    
  // Loop R1 number of times whilst adding R0 to the running total
  
(LOOP)
  
  @END // Load the address of the END instruction
  D;JEQ // If R1 == 0 then goto END

  @R0 // load the value of R0 into M
  D=M // Set D to the value of R0
  
  // ADD R2, R0
  @R2
  M=D+M // store the result back into R2
  
  // Decrement R1
  @R1
  MD=M-1 // Set R1 and the data register at the same time
  
  @LOOP // Get the address of the loop
  0;JMP // Goto LOOP
  
(END)
  @END // get ready to jump to here
  0;JMP // Infinite loop

  