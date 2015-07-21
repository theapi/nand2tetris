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
@111
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// constant
@333
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// constant
@888
D=A   // Store the numeric value in D

// PUSH
@SP
A=M   // set the address to where the SP is pointing
M=D   // store the value in the stack
@SP
M=M+1 // Advance the stack pointer

// segment direct
@8
D=A    // Store the index value in D
@StaticTest.8   // set address to StaticTest.8
D=D+A  // store the address of StaticTest.8 + index in D
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
@3
D=A    // Store the index value in D
@StaticTest.3   // set address to StaticTest.3
D=D+A  // store the address of StaticTest.3 + index in D
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
@1
D=A    // Store the index value in D
@StaticTest.1   // set address to StaticTest.1
D=D+A  // store the address of StaticTest.1 + index in D
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
@3
D=A       // Store the index value in D
@StaticTest.3   // set address to StaticTest.3
A=D+A     // set the address to be address of StaticTest.3 + index
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
@StaticTest.1   // set address to StaticTest.1
A=D+A     // set the address to be address of StaticTest.1 + index
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

// segment direct
@8
D=A       // Store the index value in D
@StaticTest.8   // set address to StaticTest.8
A=D+A     // set the address to be address of StaticTest.8 + index
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

