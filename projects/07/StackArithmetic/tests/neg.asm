// init to SP pointing to 256
@256
D=A
@SP
M=D

// constant
@9
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// constant
@6
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    neg
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=-D   // invert
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

