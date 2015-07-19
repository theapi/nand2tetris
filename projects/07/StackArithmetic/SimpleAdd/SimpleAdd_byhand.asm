// push constant 7
// push constant 8
// add

// init to sp pointing to 256
//@256
//D=A
//@SP
//M=D

////////////////////////

// push constant 7
@7
D=A   // Store the numeric value in A
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


// push constant 8
@8
D=A   // Store the numeric value in A
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer


// Add
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing
D=M    // the last entered value (8)

@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing
D=D+M    // add the value (7) to the prvious one


// push the result to the stack
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the result in the stack
@SP
M=M+1 // Advance the stack pointer

