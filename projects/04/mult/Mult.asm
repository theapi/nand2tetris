// Multiplies R0 and R1 and stores the result in R2.
// (R0, R1, R2 refer to RAM[0], RAM[1], and RAM[2], respectively.)

  @sum // location of memory holding the running total
  M=0 // initialise to zero ( sum = 0 )

  @R0 // load the value of R0 into M
  D=M // Set D to the value of R0
  
  @i // init a variable
  M=D // set i to have the value of R0 ( i = R0 )
  
  // Loop R0 number of times whilst adding R1 to the running total
  // @todo the actual loop!
  @R1 // load the value of R1 into M
  D=M // Set D to the value of R1
  
  @sum // load the sum into M
  D = D + M // Add R1 to the total
  
  @sum
  M=D // remember the result

  @R1 // load the value of R1 into M
  D=M // Set D to the value of R1
  
  @sum // load the sum into M
  D = D + M // Add R1 to the total