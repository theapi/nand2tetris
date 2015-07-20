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
@3030
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// segment direct
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M   // store popped value in D
@R3   // set address to R3
M=D   // store the value at the address
// constant
@3040
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// segment direct
@1
D=A    // Store the index value in D
@R3   // set address to R3
D=D+A  // store the address of R3 + index in D
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
// constant
@32
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// this
@2
D=A    // Store the index value in D
@THIS   // set address to THIS
D=D+M  // store the address stored in THIS + index in D
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

// constant
@46
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// that
@6
D=A    // Store the index value in D
@THAT   // set address to THAT
D=D+M  // store the address stored in THAT + index in D
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

// segment direct
@0
D=A       // Store the index value in D
@R3   // set address to R3
A=D+A     // set the address to be address of R3 + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// segment direct
@1
D=A       // Store the index value in D
@R3   // set address to R3
A=D+A     // set the address to be address of R3 + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    add
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=D+M  // x+y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// this
@2
D=A       // Store the index value in D
@THIS   // set address to THIS
A=D+M     // set the address to be THIS + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    sub
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M-D  // x-y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// that
@6
D=A       // Store the index value in D
@THAT   // set address to THAT
A=D+M     // set the address to be THAT + index
D=M       // store the push value in D
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

//    add
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=M    // the last entered value
// POP
@SP
M=M-1  // decrement (pop) the stack pointer
A=M    // set the address to where the SP is pointing

D=D+M  // x+y
// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

