// init SP pointing to 256
@256
D=A
@SP
M=D

// init LCL pointing to 300
@300
D=A
@LCL
M=D

// init ARG pointing to 400
@400
D=A
@ARG
M=D

// init THIS pointing to 3000
@3000
D=A
@THIS
M=D

// init THAT pointing to 3010
@3010
D=A
@THAT
M=D

// constant
@10
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// local
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store popped value in D
@LCL   // set address to LCL
A=M   // use the value stored in LCL as the next address
M=D   // store the value at the address

// constant
@42
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// local
@2
D=A    // Store the index value in D
@LCL   // set address to LCL
D=D+M  // store the address of LCL + index in D
@R13  // temp store the address
M=D   // store the address in R13
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store the value in D
@R13  // R13 address
A=M   // use the value stored in R13 as the next address
M=D   // store the value at the address

